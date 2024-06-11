import { Routes,RouterModule } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { HomeComponent } from './home/home.component';
import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';


import { ClientareaComponent } from './Users/clientarea/clientarea.component';
import { DashboardComponent } from './Users/dashboard/dashboard.component';
import { TicketComponent } from './Users/ticket/ticket.component';
import { MessageComponent } from './message/message.component';
import { MaterialModule } from '../material/material.module';
import { HttpClientModule,HttpClient } from '@angular/common/http';
import { AppRoutingModuleTsModule } from './app-routing.module.ts.module';
import { SocialLoginModule, SocialAuthServiceConfig } from '@abacritt/angularx-social-login';
import { GoogleLoginProvider } from '@abacritt/angularx-social-login';
@NgModule({
    declarations:[
        

    ],
    imports: [
        MaterialModule,
        AppRoutingModuleTsModule,
        HttpClientModule,
        ClientareaComponent,
        DashboardComponent,
        TicketComponent,
        MessageComponent,
        MaterialModule,
        LoginComponent,
        HomeComponent,
    ],


  })
  export class AppModule { }
  