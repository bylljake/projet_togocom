import { Component, OnInit } from "@angular/core";
import { Router } from "@angular/router";
import { AuthenticationService } from "../../../../services/api/auth/authentication.service";
import { TokenStorageService } from "../../../../services/token/token-storage.service";
import { first } from "rxjs";

@Component({
  selector: "app-my-account",
  templateUrl: "./my-account.component.html",
  styleUrls: ["./my-account.component.scss"],
})
export class MyAccountComponent implements OnInit {
  public userName?: string;
  public profileImg?: "assets/images/dashboard/profile.jpg";

  constructor( private router: Router,
    private authService: AuthenticationService,
    private tokenStorageService: TokenStorageService) {
  }

  logoutFunc() {
    this.router.navigateByUrl('auth/login');
  }
  user: any;

  ngOnInit(): void {
    this.user = this.tokenStorageService.getUser();

  }

  public get isAuthenticated(): boolean {
    return this.tokenStorageService.isAuthenticated();
  }
/**
   * Logging out
   * @description: logout
   * @returns: void
   */
public onLogOut(): void {
  this.authService.logout() .pipe(first())
  .subscribe({
    next: (data) => {
      console.log('déconnecté',data);
      
      this.tokenStorageService.signOut();
      // Toast.fire({
      //   icon: 'success',
      //   title: 'Vous êtes déconnecté avec succès.',
      // })
      this.router.navigate(['/auth/login']);

    }});

}
}
