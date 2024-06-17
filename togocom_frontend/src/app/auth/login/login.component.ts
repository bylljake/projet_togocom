import { HttpErrorResponse } from "@angular/common/http";
import { Component, OnInit } from "@angular/core";
import { FormBuilder, Validators, FormGroup, AbstractControl } from "@angular/forms";
import { ActivatedRoute, Router } from "@angular/router";
import { first, throwError } from "rxjs";
import Swal from 'sweetalert2';
import { AuthenticationService } from "../../shared/services/api/auth/authentication.service";
import { TokenStorageService } from "../../shared/services/token/token-storage.service";
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})
@Component({
  selector: "app-login",
  templateUrl: "./login.component.html",
  styleUrls: ["./login.component.scss"],
})
export class LoginComponent implements OnInit {
  public newUser = false;
  // public user: firebase.User;
  public loginForm!: FormGroup;
  public show: boolean = false
  public errorMessage: any;
  returnUrl: string = '';
  loading = false;
  isLoggedIn = false;
  isLoginFailed = false;
  errorData : any;
  roles: string[] = [];
  name: string = 'Angular';

  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private formBuilder: FormBuilder,
     private authServcie: AuthenticationService,
    private tokenStorageService: TokenStorageService,
    
  ) {}

  ngOnInit(): void {
    this.initForm();

    // redirect to home if already logged in.
    // if (this.tokenStorageService.isAuthenticated()) {
    //   this.isLoggedIn = true;
    //   this.router.navigateByUrl(this.returnUrl);
    // }

    // get return url from route parameters or default to '/'
    this.returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/dashboard/admin';
  }
  initForm() {
    this.loginForm = this.formBuilder.group({
      email: ['', [Validators.required,Validators.email,]],
      password: ['', [Validators.required,Validators.minLength(8)]],
    });
  }

  get f(): { [key: string]: AbstractControl } {
    return this.loginForm.controls;
  }

  public get isAuthenticated(): boolean {
    return this.tokenStorageService.isAuthenticated();
  }
  onSubmitForm() {
    // stop here if form is invalid

    this.loading = true;
    const data = this.loginForm.value;
    console.log('Invalid form',data);
      const email = this.loginForm.value.email;
    const password = this.loginForm.value.password;
    this.authServcie
      .login(email, password)
        .pipe(first())
        .subscribe({
          next: (response) => {
            console.log('data',response);
            this.tokenStorageService.saveUser(response.data.user);
            this.isLoginFailed = false;
            this.isLoggedIn = true;
            if(response.data.status === 401){
              Toast.fire({
                icon: 'error',
                title: response.data.message
              });
            }else if(response.data.status.status === 200){
console.log('success',response.data.status.message);

              Toast.fire({
                icon: 'success',
                title: response.data.status.message
              });
              this.router.navigate([this.returnUrl]);
            }
          },
          error: (err: HttpErrorResponse) => {
            console.log("error",err);
            
            this.errorMessage = err.error.message;
            this.errorData = err.error.data;
            this.isLoginFailed = true;
            if (err.status === 0) {
              this.errorMessage = "Le serveur n'est pas disponible";
            }
          
            this.sendErrorNotification(this.errorMessage);
            throwError(() => this.errorMessage);
            this.loading = false;
            setTimeout(() => {
              this.errorMessage = ''; // Réinitialiser le message d'erreur
              this.errorData = null; // Réinitialiser les données d'erreur
            }, 3000)
          },
        });
    }

    private sendErrorNotification(message: string) {
      if(message) {
        // this.toast.error({
        //   detail: 'Échec de la connexion',
        //   summary: `${message} et réessayer.`,
        //   duration: 10000,
        // });
      } else {
        // this.toast.error({
        //   detail: 'Message d\'erreur',
        //   summary: `Une erreur est survenue. Réessayer après.`,
        //   duration: 10000,
        // });
      }
    }
    showPassword(){
      this.show = !this.show
    }
}

