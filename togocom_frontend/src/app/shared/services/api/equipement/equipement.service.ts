import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, Subject, catchError, tap, throwError } from 'rxjs';
import { environment } from '../../../../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class EquipementService {

  baseUrl = environment.apiUrl;

  private _refresh$ = new Subject<void>();
  constructor(private http: HttpClient) {}

  /**
   * Get all equipements.
   * @returns {Observable<any>}
   * @memberof equipementsService
   */

  get refresh$(){
    return this._refresh$;
  }
  public getAllEquipements(): Observable<any> {
    return this.http
      .get<any[]>(`${this.baseUrl}/api/auth/equipements/`)
      .pipe(
        this.cathTechnicalError());
  }

  public getById(id:string): Observable<any> {
    return this.http
      .get<any[]>(`${this.baseUrl}/api/auth/equipements/${id}`)
      .pipe(

        this.cathTechnicalError());
  }
  public addEquipements(data: any){
    return this.http.post<any>(`${this.baseUrl}/api/auth/equipements`,data).pipe(
      tap(() => {
        this._refresh$.next();
      })
    );
  }
 
  public updateEquipements(id: string, data: any){
    const headers = new HttpHeaders();
    return this.http.put<any>(`${this.baseUrl}/api/auth/equipements/${id}`,data).pipe(
      tap(() => {
        this._refresh$.next();
      })
    );
  }
 public deleteEquipements(id: string){
   return this.http.delete(`${this.baseUrl}/api/auth/equipements/${id}`).pipe(
    tap(() => {
      this._refresh$.next();
    })
  );;
 }

  private cathTechnicalError<T>() {
    return (source: Observable<T>) => {
      return source.pipe(
        catchError((res: Error) => {
          console.error('Connection refusé: ', res.message);
          return throwError((res && res.message) || 'Server error');
        })
      );
    };
  }
}
