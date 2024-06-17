import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { TranslateLoader, TranslateModule } from '@ngx-translate/core';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { SharedModule } from "./shared/shared.module";
import { AppRoutingModule } from './app-routing.module';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

// // for HttpClient import:
import { LoadingBarHttpClientModule } from '@ngx-loading-bar/http-client';
// // for Router import:
import { LoadingBarRouterModule } from '@ngx-loading-bar/router';
// // for Core import:
import { LoadingBarModule } from '@ngx-loading-bar/core';

import { AdminGuard } from './shared/guard/admin.guard';

import { AppComponent } from './app.component';
import { LoginComponent } from './auth/login/login.component';

import { OverlayModule } from '@angular/cdk/overlay';
import { authInterceptorProviders } from './shared/services/interceptor/jwt/jwt.interceptor';


@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
  ],
  imports: [
    BrowserModule,
    FormsModule,
    ReactiveFormsModule,
    OverlayModule,
    SharedModule,
    BrowserAnimationsModule,
    AppRoutingModule,
    HttpClientModule,
  TranslateModule.forRoot({

  }),
  
// for HttpClient use:
  LoadingBarHttpClientModule,
// for Router use:
  LoadingBarRouterModule,
// for Core use:
  LoadingBarModule
],
providers: [AdminGuard,authInterceptorProviders],
  bootstrap: [AppComponent]
})
export class AppModule { }
