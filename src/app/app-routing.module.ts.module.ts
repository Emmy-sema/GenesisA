import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { HomeComponent } from './home/home.component';
import { MessageComponent } from './message/message.component';
import { ClientareaComponent } from './Users/clientarea/clientarea.component';
import { DashboardComponent } from './Users/dashboard/dashboard.component';
import { TicketComponent } from './Users/ticket/ticket.component';
import { AuthGuard } from './guards/auth-guard.guard';


export const routes: Routes = [
  { path: 'login', component:LoginComponent},
  { path: '',component:HomeComponent},
  { path: 'message',component:MessageComponent},
  { 
      path: 'user',component:ClientareaComponent,
      canActivate:[AuthGuard],
      children:[
          {
              path:'dashboard',
              component:DashboardComponent,
          },
          {
              path:'tickets',
              component:TicketComponent
          }
      ]
  }
];
@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule,CommonModule]

})
export class AppRoutingModuleTsModule { }
