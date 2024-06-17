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
import { Router } from '@angular/router';

const TOKEN_KEY = 'auth-token';
const USER_KEY = 'auth-user';
const FULLNAME = 'auth-fullname';

@Injectable({
  providedIn: 'root'
})
export class TokenStorageService {

  constructor( private router: Router,) { }

  signOut(): void {
    window.sessionStorage.clear();
    sessionStorage.removeItem('fullName');
  }

  public getToken(): string | null {
    return window.sessionStorage.getItem(TOKEN_KEY);
  }

  public saveUser(user: any): void {
    window.sessionStorage.removeItem(USER_KEY);
    window.sessionStorage.setItem(USER_KEY, JSON.stringify(user));
  }

  public getUser(): any {
    const user = window.sessionStorage.getItem(USER_KEY);
    return user ? JSON.parse(user) : user;
  }

  /**
   * Checks if the user is authenticated.
   * @returns {boolean}
   */
  public isAuthenticated(): boolean {
    const userData = this.getUser(); // Obtient les données utilisateur

    if (!userData) {
      this.router.navigate(['/auth/login']); // Redirige vers la page de connexion si aucune donnée utilisateur n'est présente
      return false;
    }

    return true;
  }


}
