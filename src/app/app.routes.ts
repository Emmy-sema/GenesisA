import { Routes,RouterModule } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { HomeComponent } from './home/home.component';
import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';

import { ClientareaComponent } from './Users/clientarea/clientarea.component';
import { DashboardComponent } from './Users/dashboard/dashboard.component';

export const routes: Routes = [
    { path: 'login', component:LoginComponent},
    { path: '',component:HomeComponent},
    { 
        path: 'clientarea',component:ClientareaComponent,
        children:[
            {
                path:'dashboard',
                component:DashboardComponent,
            }
        ]
    }
];
@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule,CommonModule]
  })
  export class AppRoutingModule { }
  