/**
    * @description      :
    * @author           : BYLL JAKE
    * @group            :
    * @created          : 15/04/2023 - 17:42
    *
    * MODIFICATION LOG
    * - Version         : 1.0.0
    * - Date            : 21/10/2023
    * - Author          : BYLL jake
    * - Modification    :
**/
import { Injectable } from '@angular/core';
import {
  HttpRequest,
  HttpHandler,
  HttpEvent,
  HttpInterceptor,
  HTTP_INTERCEPTORS
} from '@angular/common/http';
import { Observable, retry } from 'rxjs';
import { TokenStorageService } from '../../token/token-storage.service';
import { AuthenticationService } from '../../api/auth/authentication.service';


@Injectable()
export class JwtInterceptor implements HttpInterceptor {
  constructor(
    private token: TokenStorageService,
    private authService: AuthenticationService
  ) {}

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    req = req.clone({
      withCredentials: true,
    });

    return next.handle(req);
  }
}

export const authInterceptorProviders = [
  { provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi: true }
];
