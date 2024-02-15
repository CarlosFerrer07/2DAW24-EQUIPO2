import { Component } from '@angular/core';
import { JumbotronComponent } from '../../components/Jumbotron/jumbotron/jumbotron.component';
import { CardComponent } from '../../components/Card/card/card.component';
import { RequestService } from '../../services/request.service';
import { DataNews } from '../../components/interfaces/news.interface';

@Component({
  selector: 'app-inicio',
  standalone: true,
  imports: [JumbotronComponent,CardComponent],
  templateUrl: './inicio.component.html',
  styleUrl: './inicio.component.css'
})
export class InicioComponent {

  public constructor(public service: RequestService) {}

  public newsArray:DataNews[] | undefined;


  ngOnInit() {
    this.getAllNews();
  }

  public getAllNews() {
    this.service.getNews().subscribe((news) => {
      this.newsArray = news;
      console.log(this.newsArray);
    })
  }
}
