import { Component } from '@angular/core';
import { NavBarComponent } from '../nav-bar/nav-bar.component';
import { ServiceService } from '../services/service.service';
import { Router } from '@angular/router';
import { AuthService } from '../services/auth.service';
import { LoginComponent } from '../login/login.component';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-message',
  standalone: true,
  imports: [NavBarComponent,LoginComponent,CommonModule],
  templateUrl: './message.component.html',
  styleUrl: './message.component.scss'
})
export class MessageComponent {
  constructor(private service:ServiceService, private router:Router,private auth:AuthService){}
  email:String = '';
  loader:Boolean = false;
  message:String = '';
  error:String = '';
  ngOnInit(): void {
    this.animation()
    this.service.currentMessage.subscribe(
      message=>{
        if (message == ''){
          this.router.navigate(['../'])
        }else{
          this.email = message
        }
      }
    )
  }

  // to be continued
  animation(){
    let left = document.getElementById('left');
    let right = document.getElementById('right');
    let top = document.getElementById('top');
    let bottom = document.getElementById('bottom');
    const maxLength = 500;
    const maxWidth = 400;


  }
  ngAfterViewInint(){

  }
  submit(){
    if(this.email !== ''){
      let user = {
        'email' : this.email
      }
      this.loader = true;
      this.auth.re_send_confirmation(user).subscribe(
        res=>{
          console.log(res.message)
          if(res.success){
            this.loader= false;
            this.message = res.message
          }else{
            this.error = res.message
          }
        }
      );
    }
  }
}


