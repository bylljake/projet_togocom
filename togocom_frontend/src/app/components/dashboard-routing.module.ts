import { NgModule } from "@angular/core";
import { RouterModule, Routes } from "@angular/router";
import { DashboardComponent } from "./dashboard/dashboard.component";
import { AdminGuard } from "../shared/guard/admin.guard";
import { AddEditRanComponent } from "./ran/add-edit-ran/add-edit-ran.component";
import { AddEditEquipementsComponent } from "./equipement/add-edit-equipements/add-edit-equipements.component";
import { AddEditSitesComponent } from "./sites/add-edit-sites/add-edit-sites.component";
import { ListSitesComponent } from "./sites/list-sites/list-sites.component";
import { ListEquipementsComponent } from "./equipement/list-equipements/list-equipements.component";

const routes: Routes = [
  {
    path: "",
    children: [
      {
        path: "admin",
        component: DashboardComponent,
      },
      {
        path: "ran",
        component: AddEditRanComponent,
      },
      {
        path: "sites/create",
        component: AddEditSitesComponent,
      },
      {
        path: "sites/update/:id",
        component: AddEditSitesComponent,
      },
      {
        path: "sites/list",
        component: ListSitesComponent,
      },
      {
        path: "equipement/create",
        component: AddEditEquipementsComponent,
      },
      {
        path: "equipement/update/:id",
        component: AddEditEquipementsComponent,
      },
      {
        path: "equipement/list",
        component: ListEquipementsComponent,
      },
  
    ],
  },
];
@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class DashboardRoutingModule {}
