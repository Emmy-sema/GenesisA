import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';

import { NavBarComponent } from '../nav-bar/nav-bar.component';
import { WelcomeComponent } from '../welcome/welcome.component';
import { SecondPageComponent } from '../second-page/second-page.component';
import { ThirdPageComponent } from '../third-page/third-page.component';
import { HostingPlanComponent } from '../hosting-plan/hosting-plan.component';
import { SecurityComponent } from '../security/security.component';
import { FooterComponent } from '../footer/footer.component';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [
    CommonModule,
    NavBarComponent,
    WelcomeComponent,
    SecondPageComponent,
    ThirdPageComponent,
    HostingPlanComponent,
    SecurityComponent,
    FooterComponent
  ],
  templateUrl: './home.component.html',
  styleUrl: './home.component.scss'
})
export class HomeComponent {

}
