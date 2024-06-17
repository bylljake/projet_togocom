import { Component } from '@angular/core';
import { SitesService } from '../../../shared/services/api/sites/sites.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-list-sites',
  templateUrl: './list-sites.component.html',
  styleUrls: ['./list-sites.component.scss']
})
export class ListSitesComponent {

  Sites: any[] = [];
  constructor( private router: Router, private siteService: SitesService,) { }
   
    ngOnInit(): void {
    
      this.dataTableSites();
      
    }
    dataTableSites() {
      this.siteService.getAllSites().subscribe((response: any) => {
        this.Sites = response.data;
        console.log('Sites',this.Sites);
      });
    }
    viewDetails(site: any) {
      this.router.navigate(['/dashboard/equipement/create'], { state: { site } });
    }
}
