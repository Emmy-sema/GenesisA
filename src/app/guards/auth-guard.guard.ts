import { CanActivateFn,Router,ActivatedRouteSnapshot,RouterStateSnapshot } from '@angular/router';
import { AuthService } from '../services/auth.service';
import { Injectable, inject } from '@angular/core';
import { Subscription } from 'rxjs';

@Injectable({
  providedIn: 'root'
})

class PermissionsService {

  constructor(private router: Router, private auth:AuthService) {}
  Subscribtion: Subscription = new Subscription;
  loginStatus:Boolean = false;
  canActivate(next: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean {
      //your logic goes here
      let value = false;
      this.Subscribtion = this.auth.currentStatus.subscribe(res => this.loginStatus = res)
      if(this.loginStatus){
        value = true;
      }else{
        this.auth.Is_logged_in().subscribe(
          res=>{
            if(res.success){
              this.auth.update_current_user(res)
              this.auth.setLoggedInStatus(true);
              this.router.navigate(['/user/dashboard']);
              value = true
            }else{
              this.auth.setLoggedInStatus(false);
              this.router.navigate(['/login']);
              value = false
            }
          })
      }

      return value;
  }
}

export const AuthGuard: CanActivateFn = (next: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean => {
  return inject(PermissionsService).canActivate(next, state);
}
;
