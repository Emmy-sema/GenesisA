import { Injectable } from '@angular/core';
import { HttpHeaders, HttpClient} from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor(private http:HttpClient) { }

  createAccount(user: any):Observable<any>{
    return this.http.post<any>('api/createAccount.php',user)
  }

  login(user:any):Observable<any>{
    return this.http.post<any>('apil/login.php',user)
  }
  
}
