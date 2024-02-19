import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { DataNews } from '../components/interfaces/news.interface';


@Injectable({
  providedIn: 'root'
})
export class RequestService {

  constructor(public http:HttpClient) { }

  public getNews():Observable<DataNews[]>{
    return this.http.get<DataNews[]>('http://localhost:8000/newsJson');
    }
    
}
