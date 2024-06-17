import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { FullComponent } from './shared/components/layout/full/full.component';
import { AdminGuard } from './shared/guard/admin.guard';
import { full } from './shared/routes/full.routes';
import { ContentComponent } from './shared/components/layout/content/content.component';
import { content } from './shared/routes/routes';
import { LoginComponent } from './auth/login/login.component';

const routes: Routes = [
  {
    path: '',
    redirectTo: 'auth/login',
    pathMatch: 'full'
  },
  {
    path: 'auth/login',
    component: LoginComponent,
  },
  {
    path: '',
    component: ContentComponent,
    canActivate: [AdminGuard],
    children: content
  },
  {
    path: '',
    component: FullComponent,
    canActivate: [AdminGuard],
    children: full
  },
  {
    path: '**',
    redirectTo: ''
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
