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
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { EventEmitter, Injectable, Output } from '@angular/core';
import { map, Observable } from 'rxjs';
import { environment } from '../../../../../environments/environment';
import { LoginResponse } from '../../models/login/login-response.payload';

const httpOptions = {
  withCredentials: true,
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable({
  providedIn: 'root'
})
export class AuthenticationService {

  public apiURL = environment.apiUrl;

  @Output() name: EventEmitter<string> = new EventEmitter();
  @Output() token: EventEmitter<string> = new EventEmitter();

  constructor(private http: HttpClient) { }

  login(email: string, password: string): Observable<LoginResponse> {
    return this.http.post<LoginResponse>(`${this.apiURL}/api/auth/login`, {
     email,
      password
    }, httpOptions).pipe(map(response => {
      return response;
    }));
  }


  logout() {
    return this.http
      .post(
        `${this.apiURL}/api/auth/logout`,
        {},
        {
          withCredentials: true,
        }
      ).pipe(map(response => {
        return response;
      }));
  }

}
