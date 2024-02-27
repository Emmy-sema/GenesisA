import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink, RouterLinkActive, RouterOutlet } from '@angular/router';
import { DashboardComponent } from '../dashboard/dashboard.component';
import { TicketComponent } from '../ticket/ticket.component';
import { MaterialModule } from '../../../material/material.module';

@Component({
  selector: 'app-clientarea',
  standalone: true,
  imports: [
    CommonModule,
    MaterialModule,
    RouterLink,
    RouterOutlet,
    RouterLinkActive,
    DashboardComponent,
    TicketComponent
  ],
  templateUrl: './clientarea.component.html',
  styleUrl: './clientarea.component.scss'
})
export class ClientareaComponent {

}
