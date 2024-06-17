import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { EquipementService } from '../../../shared/services/api/equipement/equipement.service';

@Component({
  selector: 'app-list-equipements',
  templateUrl: './list-equipements.component.html',
  styleUrls: ['./list-equipements.component.scss']
})
export class ListEquipementsComponent {
  Equipements: any[] = [];
  constructor( private router: Router, private equipementService: EquipementService,) { }
   
    ngOnInit(): void {
    
      this.dataTableEquipements();
      
    }
    dataTableEquipements() {
      this.equipementService.getAllEquipements().subscribe((response: any) => {
        this.Equipements = response.data;
        console.log('Equipements',this.Equipements);
      });
    }
}
