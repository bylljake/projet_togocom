import { Component } from '@angular/core';

@Component({
  selector: 'app-add-edit-ran',
  templateUrl: './add-edit-ran.component.html',
  styleUrls: ['./add-edit-ran.component.scss']
})
export class AddEditRanComponent {
  returnUrl: string = '';
  selectedFile: any;
  isChecked = false;
  loading = false;
  isLoggedIn = false;
  isParishFailed = false;
  errorMessage = '';
  imageUrl: string | ArrayBuffer | null = null;
  imageSelected: boolean = false;
  showInput: boolean = false;
  constructor(  ) { }
ngAfterViewInit(): void {

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
}
