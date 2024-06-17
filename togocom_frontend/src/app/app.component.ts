import { Component } from '@angular/core';
import { AbstractControl, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  public newUser = false;
  // public user: firebase.User;
  public loginForm: FormGroup;
  public show: boolean = false
  public errorMessage: any;

  constructor(private fb: FormBuilder, public router: Router) {
    this.loginForm = this.fb.group({
      email: ["Test@gmail.com", [Validators.required, Validators.email]],
      password: ["test123", Validators.required],
    });
  }

  ngOnInit() {}
  get f(): { [key: string]: AbstractControl } {
    return this.loginForm.controls;
  }
  login() {
    if (this.loginForm.value["email"] == "Test@gmail.com" && this.loginForm.value["password"] == "test123") {
      let user = {
        email: "Test@gmail.com",
        password: "test123",
        name: "test user",
      };
      localStorage.setItem("user", JSON.stringify(user));
      this.router.navigate(["/dashboard/default"]);
    }
  }

  showPassword(){
    this.show = !this.show
  }
}
