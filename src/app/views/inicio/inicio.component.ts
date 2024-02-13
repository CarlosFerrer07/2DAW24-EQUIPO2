import { Component } from '@angular/core';
import { JumbotronComponent } from '../../components/Jumbotron/jumbotron/jumbotron.component';
import { CardComponent } from '../../components/Card/card/card.component';

@Component({
  selector: 'app-inicio',
  standalone: true,
  imports: [JumbotronComponent,CardComponent],
  templateUrl: './inicio.component.html',
  styleUrl: './inicio.component.css'
})
export class InicioComponent {
images= ["https://pxbar.com/wp-content/uploads/2023/09/goofy-ahh-pictures-14.jpg","https://pxbar.com/wp-content/uploads/2023/09/goofy-ahh-pictures-15.jpg","https://pxbar.com/wp-content/uploads/2023/09/wallpaper-goofy-ahh-pictures.jpg"]
Title= ["RAHHH","aASDSGFHF","CXZVBVN"]
Text= ["","",""]
}
