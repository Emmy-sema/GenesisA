import { Inject, Injectable, OnInit, PLATFORM_ID } from '@angular/core';
import { HttpHeaders, HttpClient} from '@angular/common/http';
import { BehaviorSubject, Observable } from 'rxjs';
import { isPlatformBrowser } from '@angular/common';

@Injectable({
  providedIn: 'root'
})
export class AuthService implements OnInit {

  constructor(private http:HttpClient, @Inject(PLATFORM_ID) private platformId: Object) { }

  ngOnInit(): void {
   
  }
   
  get_csrf_token(){
    if (isPlatformBrowser(this.platformId)) {
      return sessionStorage.getItem('csrf_token')
    }
    return false
  }
      
  private user = new BehaviorSubject<any>({success:false});
  currentUser = this.user.asObservable()
  
  update_current_user(info:any){
    this.user.next(info);
  }
  set_csrf_token(value:string){
    if (isPlatformBrowser(this.platformId)) {
      return sessionStorage.setItem('csrf_token',value) 
    }
    return false
  }
 
  
  private loggedInStatus= new BehaviorSubject<boolean>(false);
  currentStatus = this.loggedInStatus.asObservable();

  setLoggedInStatus(value:boolean){
    this.loggedInStatus.next(value)
  }
  
  
  logOut():Observable<any>{
    return this.http.get<any>('api/auth/log_out.php');
  }
  createAccount(user: any):Observable<any>{
    return this.http.post<any>('api/auth/createAccount.php',user)
  }

  login(user:any):Observable<any>{
    return this.http.post<any>('api/auth/login.php',user)
  }

  Is_logged_in():Observable<any>{
    return this.http.get<any>('api/auth/is_logged_in.php')
  }

  loginProvider(user:any):Observable<any>{
    return this.http.post<any>('api/auth/providerLogin.php',user);
  }
  re_send_confirmation(email:Object):Observable<any>{
    return this.http.post<any>('api/auth/re_send_activation.php',email)
  }


}
