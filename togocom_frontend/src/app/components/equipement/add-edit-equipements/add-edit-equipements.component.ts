import { Component } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { EquipementService } from '../../../shared/services/api/equipement/equipement.service';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import Swal from 'sweetalert2';
import { HttpErrorResponse } from '@angular/common/http';
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
});


@Component({
  selector: 'app-add-edit-equipements',
  templateUrl: './add-edit-equipements.component.html',
  styleUrls: ['./add-edit-equipements.component.scss']
})
export class AddEditEquipementsComponent {
  returnUrl: string = '';
  selectedFile: any;
  isChecked = false;
  site: any;
  formEquipement!: FormGroup;
  loading = false;
  equipementId: number = 0;
  isLoggedIn = false;
  isParishFailed = false;
  errorMessage = '';
  imageUrl: string | ArrayBuffer | null = null;
  imageSelected: boolean = false;
  showInput: boolean = false;
  constructor( private router: Router,  private route: ActivatedRoute,
    private formBuilder: FormBuilder,
    private sitesService: EquipementService,  ) {
      const navigation = this.router.getCurrentNavigation();
      if (navigation?.extras?.state) {
        this.site = navigation.extras.state['site'];
        console.log('site',this.site);
        
      }
     }
ngAfterViewInit(): void {

}


 
  // ngOnInit(): void {
  //   if (!this.site) {
  //     // Gérer le cas où les données ne sont pas présentes
  //     this.router.navigate(['/']);
  //   }
  // }

  ngOnInit(): void{
    let id = this.route.snapshot.params['id'];
    this.siteById(id);
    if (id) {
      this.isParishFailed = true;
      this.equipementId = id;
      console.log('Mode modification - id', id);
     
    } else {
      console.log('Mode ajout');
    }
    this.formEquipement = this.formBuilder.group({
      name: ['', [Validators.required,Validators.minLength(3)]],
      type: ['', [Validators.required,]],
      description: ['', [Validators.required,]],
      quantity: ['', [Validators.required,]],
      sites_id: ['', [Validators.required,]],
      images: ['', [Validators.required,]],
    });
  }
    onFileSelected(event: any) {
      const file: File = event.target.files[0];
      console.log("image",file);
      if (file) {
        this.selectedFile = file;
        this.imageSelected = true;
        const reader = new FileReader();
        reader.onload = (e: any) => {
          this.imageUrl = e.target.result;
        };
        reader.readAsDataURL(file);
    }
    }
  
    siteById(id:string){
      this.sitesService.getById(id).pipe().subscribe({
        next: (res) => {
          console.log('byId',res);
          this.formEquipement.controls['name'].patchValue(res.name);
          this.formEquipement.controls['type'].patchValue(res.type);
          this.formEquipement.controls['description'].patchValue(res.description);
          this.formEquipement.controls['quantity'].patchValue(res.quantity);
          this.formEquipement.controls['sites_id'].patchValue(res.sites_id);
          this.formEquipement.controls['images'].patchValue(res.images);
          this.imageUrl = "data:image;base64,"+res.images
        }
      })
     }
    submitSite(){
      console.log('site',this.site.site_id);
      const siteData = this.formEquipement.value;
      const formData: FormData = new FormData();
  
      // Ajoutez chaque champ du formulaire à l'objet FormData
      formData.append('images', this.selectedFile);
      formData.append('name', this.formEquipement.get('name')!.value);
      formData.append('type', this.formEquipement.get('type')!.value);
      formData.append('description', this.formEquipement.get('description')!.value);
      formData.append('quantity', this.formEquipement.get('quantity')!.value);
      formData.append('sites_id', this.site.site_id);
      const data = { ...siteData , images: this.selectedFile};
  
      console.log('data',data);
      const id = this.route.snapshot.params['id'];
      if (id) {
        formData.append("_method", "PUT");
        this.sitesService.updateEquipements(id,formData).subscribe({
         next: (res) => {
           console.log('datass',res.message);
           Toast.fire({
             icon: 'success',
             title: res.message
           });
           this.router.navigateByUrl('/dashboard/equipement/list');
         }
         ,error: (err: HttpErrorResponse) => {
           console.log("error",err);
           Toast.fire({
             icon: 'error',
             title: err.error.message
           })
           this.errorMessage = err.error.message;
           this.isParishFailed = true;
           this.loading = false;
         },})
       }else {
      this.sitesService.addEquipements(formData).pipe().subscribe({
        next: (res) => {
          console.log('datas',res.message);
          Toast.fire({
            icon: 'success',
            title: res.message
          });
          this.router.navigateByUrl('/dashboard/equipement/list');
        }
        ,error: (err: HttpErrorResponse) => {
          console.log("error",err);
          Toast.fire({
            icon: 'error',
            title: err.error.message
          })
          this.errorMessage = err.error.message;
          this.loading = false;
        },})}
    }
  }
  