import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MaterialModule } from '../../material/material.module';
import { RouterLink, RouterLinkActive, RouterOutlet } from '@angular/router';
import { ServiceService } from '../services/service.service';
@Component({
  selector: 'app-nav-bar',
  standalone: true,
  imports: [
    CommonModule,
    MaterialModule,
    RouterLink,
    RouterOutlet, 
    RouterLinkActive,
  ],
  templateUrl: './nav-bar.component.html',
  styleUrl: './nav-bar.component.scss'
})
export class NavBarComponent {
  constructor(private service:ServiceService) {}

  scroll(){
    this.service.updateScroll(true)
  }
  
  sendanimation(value: boolean){
    this.service.updateFlip(value)
  }
}
