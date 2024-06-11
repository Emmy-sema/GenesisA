import { HttpEvent, HttpHandler, HttpInterceptor, HttpRequest } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Observable } from "rxjs";
import { AuthService } from "./auth.service";
import { switchMap } from 'rxjs/operators';


@Injectable()
export class AuthInterceptor implements HttpInterceptor {
    constructor(private auth: AuthService) {}

    intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        
        const csrfToken  = this.auth.get_csrf_token();
        if(csrfToken){
            if (req.method.toUpperCase() == 'POST'){
                const clonedRequest = req.clone({
                    body:req.body.append('csrf_token',csrfToken)
                });
                return next.handle(clonedRequest)
            }else{
                const clonedRequest = req.clone({
                    params: req.params.set('csrf_token', csrfToken)
                });
                return next.handle(clonedRequest)
            }
        }else{
            return next.handle(req)
        }

    }
    
}