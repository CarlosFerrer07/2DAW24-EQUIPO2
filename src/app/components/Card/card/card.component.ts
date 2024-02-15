import { Component,Input,Output,EventEmitter } from '@angular/core';
import { DataNews } from '../../../../interfaces/news.interface';

@Component({
  selector: 'app-card',
  standalone: true,
  imports: [],
  templateUrl: './card.component.html',
  styleUrl: './card.component.css'
})
export class CardComponent {

  @Input() nameNew: string | undefined;

  @Input() description: string | undefined;



}
