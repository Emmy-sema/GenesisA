import { Component, OnInit } from '@angular/core';
import  {MatIconModule} from '@angular/material/icon'
import { RouterLink, Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';
@Component({
  selector: 'app-dashboard',
  standalone: true,
  imports: [
    MatIconModule,
    RouterLink
  ],
  templateUrl: './dashboard.component.html',
  styleUrl: './dashboard.component.scss'
})
export class DashboardComponent implements OnInit{
  constructor(private auth:AuthService, private router:Router){}
  data:any;
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

  log_out(){
    this.auth.logOut().subscribe(
      res =>{
        if(res){
          // purge last login data and set loginStatus to false
          this.auth.setLoggedInStatus(false)
          this.auth.update_current_user({success:false});
          this.router.navigate(['/'])
        }else{
          alert('Unsuccesfull, try again')
        }
      }
    )
    
  }
}
