import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink, RouterLinkActive, RouterOutlet, Router} from '@angular/router';
import { DashboardComponent } from '../dashboard/dashboard.component';
import { TicketComponent } from '../ticket/ticket.component';
import { MaterialModule } from '../../../material/material.module';
import { AuthService } from '../../services/auth.service';

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
export class ClientareaComponent implements OnInit{
  data:any;
  constructor(private auth:AuthService, private router:Router){}
  ngOnInit(): void {
    this.auth.currentUser.subscribe(
      res =>{
        if(res.success){
          this.data = res.info
        }else{
          this.auth.Is_logged_in().subscribe(
          res =>{
            if(res.success){
              this.data = res.info
            }else{
              this.router.navigate(['/'])
            }
          }
        )
        }
       
      }
    )

  }
 
}
