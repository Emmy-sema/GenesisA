import { ApplicationConfig } from '@angular/core';
import { provideRouter } from '@angular/router';

import { routes } from './app-routing.module.ts.module';
import { provideClientHydration } from '@angular/platform-browser';
import { provideAnimationsAsync } from '@angular/platform-browser/animations/async';
import { HTTP_INTERCEPTORS, provideHttpClient, withFetch, withInterceptorsFromDi } from '@angular/common/http';
import { FacebookLoginProvider, GoogleLoginProvider, SocialAuthServiceConfig } from '@abacritt/angularx-social-login';
import { AuthInterceptor } from './services/auth.intercepter';


export const appConfig: ApplicationConfig = {
  providers: [
    {
      provide:HTTP_INTERCEPTORS,
      useClass: AuthInterceptor,
      multi:true
    },
    provideRouter(routes), 
    provideClientHydration(), 
    provideAnimationsAsync(), 
    provideAnimationsAsync(),
    provideHttpClient(withFetch(),withInterceptorsFromDi()),
    {
      provide: 'SocialAuthServiceConfig',
      useValue: {
        autoLogin: false,
        providers: [
          {
            id: GoogleLoginProvider.PROVIDER_ID,
            provider: new GoogleLoginProvider(
              '156907984278-ph2anv5d96uphie0ft9g3vae8dqhv6tp.apps.googleusercontent.com'
            )
          },
          {
            id: FacebookLoginProvider.PROVIDER_ID,
            provider: new FacebookLoginProvider('1442502383295105')
          }
        ]

      } as SocialAuthServiceConfig,
    }    
  ]
};
