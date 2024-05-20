import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { NavBarComponent } from '../nav-bar/nav-bar.component';
import { RouterLink, RouterLinkActive, RouterOutlet } from '@angular/router';
import { AuthService } from '../services/auth.service';
import { ServiceService } from '../services/service.service';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [
    CommonModule,
    NavBarComponent,
    RouterLink,
    RouterOutlet, 
    RouterLinkActive,
  ],
  templateUrl: './login.component.html',
  styleUrl: './login.component.scss'
})
export class LoginComponent {

  // constructor(private service:ServiceService){}

  
  animation(value: boolean){
    var element = document.getElementById('form')
    var sign = document.getElementById('signIn')
    var register = document.getElementById('register')

    if (element !== null && sign !== null && register !== null){
      if(!value){
        element.style.transform = 'rotateY(360deg)';
        sign.style.borderBottom = "thin solid white";
        register.style.borderBottom = "0px solid transparent";

      }else{
        element.style.transform = 'rotateY(180deg)';
        sign.style.borderBottom = "0px solid transparent";
        register.style.borderBottom = "thin solid white";

      }
    }
  }
}
