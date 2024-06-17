import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { SitesService } from '../../../shared/services/api/sites/sites.service';
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
  selector: 'app-add-edit-sites',
  templateUrl: './add-edit-sites.component.html',
  styleUrls: ['./add-edit-sites.component.scss']
})
export class AddEditSitesComponent {
  returnUrl: string = '';
  selectedFile: any;
  siteId: number = 0;
  isChecked = false;
  loading = false;
  isLoggedIn = false;
  isParishFailed = false;
  errorMessage = '';
  imageUrl: string | ArrayBuffer | null = null;
  imageSelected: boolean = false;
  showInput: boolean = false;
  formSites!: FormGroup;
  constructor( private router: Router,  private route: ActivatedRoute,
    private formBuilder: FormBuilder,
    private sitesService: SitesService, ) { }
ngAfterViewInit(): void {

}
ngOnInit(): void{
  let id = this.route.snapshot.params['id'];
  this.siteById(id);
  if (id) {
    this.isParishFailed = true;
    this.siteId = id;
    console.log('Mode modification - id', id);
   
  } else {
    console.log('Mode ajout');
  }
  this.formSites = this.formBuilder.group({
    name: ['', [Validators.required,Validators.minLength(3)]],
    location: ['', [Validators.required,]],
    description: ['', [Validators.required,]],
    superficie: ['', [Validators.required,]],
    date_of_create: ['', [Validators.required,]],
    date_of_service: ['', [Validators.required,]],
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
        this.formSites.controls['name'].patchValue(res.name);
        this.formSites.controls['location'].patchValue(res.location);
        this.formSites.controls['description'].patchValue(res.description);
        this.formSites.controls['superficie'].patchValue(res.superficie);
        this.formSites.controls['date_of_create'].patchValue(res.date_of_create);
        this.formSites.controls['date_of_service'].patchValue(res.date_of_service);
        this.formSites.controls['images'].patchValue(res.images);
        this.imageUrl = "data:image;base64,"+res.images
      }
    })
   }
  submitSite(){
    console.log('site',this.formSites.value);
    const siteData = this.formSites.value;
    const formData: FormData = new FormData();

    // Ajoutez chaque champ du formulaire à l'objet FormData
    formData.append('images', this.selectedFile);
    formData.append('name', this.formSites.get('name')!.value);
    formData.append('location', this.formSites.get('location')!.value);
    formData.append('description', this.formSites.get('description')!.value);
    formData.append('superficie', this.formSites.get('superficie')!.value);
    formData.append('date_of_create', this.formSites.get('date_of_create')!.value);
    formData.append('date_of_service', this.formSites.get('date_of_service')!.value);
    const data = { ...siteData , images: this.selectedFile};

    console.log('data',data);
    const id = this.route.snapshot.params['id'];
    if (id) {
      formData.append("_method", "PUT");
      this.sitesService.updateSites(id,formData).subscribe({
       next: (res) => {
         console.log('datass',res.message);
         Toast.fire({
           icon: 'success',
           title: res.message
         });
         this.router.navigateByUrl('/dashboard/sites/list');
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
    this.sitesService.addSites(formData).pipe().subscribe({
      next: (res) => {
        console.log('datas',res.message);
        Toast.fire({
          icon: 'success',
          title: res.message
        });
        this.router.navigateByUrl('/dashboard/sites/list');
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
