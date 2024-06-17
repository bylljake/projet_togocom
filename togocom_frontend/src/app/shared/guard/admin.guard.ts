import { Injectable } from "@angular/core";
import { ActivatedRouteSnapshot, RouterStateSnapshot, Router, UrlTree } from "@angular/router";
import { Observable } from "rxjs";
import { TokenStorageService } from "../services/token/token-storage.service";
@Injectable({
  providedIn: "root",
})
export class AdminGuard  {
  constructor(public router: Router,private authService: TokenStorageService) {}

  canActivate(
    route: ActivatedRouteSnapshot,
    state: RouterStateSnapshot
  ):
    | Observable<boolean | UrlTree>
    | Promise<boolean | UrlTree>
    | boolean
    | UrlTree {
    if (!this.authService.isAuthenticated()) {
      return this.router.createUrlTree([
        '/auth/login',
        { message: "Vous_navez_pas_l'autorisation_d'entrer" },
      ]);
    } else {
        return true;
      }
  }
}
