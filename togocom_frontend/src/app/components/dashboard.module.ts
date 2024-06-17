import { CommonModule } from "@angular/common";
import { NgModule } from "@angular/core";
import { NgbModule } from "@ng-bootstrap/ng-bootstrap";
import { FormsModule } from "@angular/forms";
import { DashboardRoutingModule } from "./dashboard-routing.module";
import { GoogleMapsModule } from "@angular/google-maps";
import { SharedModule } from "../shared/shared.module";
import { DashboardComponent } from "./dashboard/dashboard.component";
import { AddEditRanComponent } from './ran/add-edit-ran/add-edit-ran.component';
import { AddEditSitesComponent } from './sites/add-edit-sites/add-edit-sites.component';
import { AddEditEquipementsComponent } from './equipement/add-edit-equipements/add-edit-equipements.component';
import { ListSitesComponent } from './sites/list-sites/list-sites.component';
import { ListEquipementsComponent } from './equipement/list-equipements/list-equipements.component';


@NgModule({
  declarations: [
    DashboardComponent,
    AddEditRanComponent,
    AddEditSitesComponent,
    AddEditEquipementsComponent,
    ListSitesComponent,
    ListEquipementsComponent,
  ],
  imports: [
    CommonModule, // Import CommonModule instead of BrowserModule
    SharedModule,
    GoogleMapsModule,
    NgbModule,
    FormsModule,
    DashboardRoutingModule
  ],
  exports: []
})
export class DashboardModule {}
