import { Component,Input,Output,EventEmitter } from '@angular/core';
import { DataNews } from '../../interfaces/news.interface';

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

  @Input() id: number | undefined;

  @Input() date: Date | undefined;

  @Input() image: string | undefined;

  formattedDate: string | undefined;

  ngOnInit() {
    if (this.date) {
      const dateObj = new Date(this.date);
      this.formattedDate = dateObj.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
    }
  }

  onShowModal() {
    alert('Aqui va el modal');
  }

}
