import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { NavBarComponent } from '../nav-bar/nav-bar.component';
import { RouterLink, RouterLinkActive, RouterOutlet} from '@angular/router';
import { AuthService } from '../services/auth.service';
import { AbstractControl, FormControl, FormGroup,ReactiveFormsModule, Validators } from '@angular/forms';
import { ServiceService } from '../services/service.service';
import { Router } from '@angular/router';
import { FacebookLoginProvider, SocialAuthService  } from '@abacritt/angularx-social-login';
import { GoogleSigninButtonModule } from '@abacritt/angularx-social-login';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [
    CommonModule,
    NavBarComponent,
    RouterLink,
    RouterOutlet, 
    RouterLinkActive,
    ReactiveFormsModule,
    GoogleSigninButtonModule,
    
  ],
  templateUrl: './login.component.html',
  styleUrl: './login.component.scss',
  
})

export class LoginComponent {
  constructor(private auth:AuthService, private service:ServiceService,private router:Router,private providerAuth: SocialAuthService){}
  socialUser:any="";

  ngOnInit(){
    // * checks authstate, doesn't acctually login
    this.providerAuth.authState.subscribe((user) => {
      console.log('fuck',user)
      this.socialUser = user;
      const formDAta = new FormData()
      formDAta.append('firstName',user.firstName)
      formDAta.append('lastName',user.lastName)
      formDAta.append('email',user.email)
      formDAta.append('photoUrl',user.photoUrl)
      formDAta.append('provider',user.provider)

      this.auth.loginProvider(formDAta).subscribe(
        res=>{
          if(res.success){
            this.auth.set_csrf_token(res.csrf_token)
            this.router.navigate(['/user/dashboard'])
          }else{
            this.loginMessage = res.message
          }
        }
      )
    });

  }


  signInWithFB(): void {
    this.providerAuth.signIn(FacebookLoginProvider.PROVIDER_ID)
    .then(res=>{
    });
  }
  
  isSubmitted:boolean = false
  message:string = '';
  email:string='';
  loginMessage:String = '';
  login = new FormGroup({
    userName: new FormControl('',[Validators.required,this.emailValidator]),
    password: new FormControl('',Validators.required)
  })
  
  createAccount = new FormGroup({
    fName: new FormControl('',Validators.required),
    lName: new FormControl('',Validators.required),
    email: new FormControl('',[Validators.required,this.emailValidator]),
    password: new FormControl('',[Validators.required,this.passwordStrengthValidator]),
    number: new FormControl('',Validators.required)
  })
 
  

  animation(value: boolean){
    var element = document.getElementById('form')
    var sign = document.getElementById('signIn')
    var register = document.getElementById('register')
    var line = document.getElementById('line')

    if (element !== null && sign !== null && register !== null && line){
      if(!value){
        element.style.transform = 'rotateY(360deg)';
        sign.style.borderBottom = "thin solid white";
        register.style.borderBottom = "0px solid transparent";
        line.style.margin = "1rem auto"

      }else{
        element.style.transform = 'rotateY(180deg)';
        sign.style.borderBottom = "0px solid transparent";
        register.style.borderBottom = "thin solid white";
        line.style.margin = "12rem auto 2rem auto"

      }
    }
  }

  signUp(form:any){
    this.isSubmitted = true
    if (this.createAccount.valid){
      this.email = form.value.email
      const formData = new FormData();
      formData.append('email',form.value.email);
      formData.append('password',form.value.password);
      formData.append('firstName',form.value.fName);
      formData.append('lastName',form.value.lName);
      formData.append('number',form.value.number);

      this.auth.createAccount(formData).subscribe(
        res=>{
         if (res.success){
          this.service.updateMessage(form.value.email)
          this.router.navigate(['message']);
         }else{
          this.message = res.message
         }
        })
    }
  }

  signIn(form:any){
    if(this.login.valid){
      const formData = new FormData();
      formData.append('email',form.value.userName);
      formData.append('password',form.value.password);
      this.auth.login(formData).subscribe(
        res=>{
          if(res.success){
            this.auth.set_csrf_token(res.csrf_token)
            this.router.navigate(['/user/dashboard'])
          }else{
            this.loginMessage = res.message
          }
        }
      )
    }
  }


  get formControls(){
    return this.createAccount['controls']
  }
  passwordStrengthValidator(control:AbstractControl){
    var password = control.value
    var length = password.length >= 8
    var haslowerCase = /[A-Z]/.test(password)
    var hasCapitalLetter = /[A-Z]/.test(password)
    var hasSpecialCharacters = /[!@#$%^&*()_+]/.test(password)
    var hasNumber = /[1234567890]/.test(password)
    var valid = length && hasCapitalLetter && hasSpecialCharacters && hasNumber
    if(!valid) {
      if(!hasNumber){
          return {'hasNumber':false}
      }else if(!hasCapitalLetter){
        return {'hasCapitalLetter': false}
      }else if(!hasSpecialCharacters){
        return {'hasSpecialCharacters': false}
      }else if(haslowerCase){
        return {'haslowerCase': false}
      }else if(password.length < 8){
        return {'passwordlegth': false}
      }
    }
    return null
  }
  emailValidator(control:AbstractControl){
    if((control.value).length >50){
      return {'emailLength':false}
    }else if(!/[a-zA-z-.\d]+@[a-zA-z-_]+\.[a-z]+/.test(control.value)){
      return {'Valid':false}
    }
    return null
  }
}
