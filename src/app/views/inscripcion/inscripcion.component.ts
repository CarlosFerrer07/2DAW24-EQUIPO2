import { Component } from '@angular/core';
import { ReactiveFormsModule, FormGroup, FormControl } from '@angular/forms';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-inscripcion',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './inscripcion.component.html',
  styleUrl: './inscripcion.component.css'
})
export class InscripcionComponent {

  constructor(private http: HttpClient) { }

  reactiveForm = new FormGroup({
    nombre: new FormControl('', { nonNullable: true }),
    apellidos: new FormControl('', { nonNullable: true }),
    dni: new FormControl('', { nonNullable: true }),
    pasaporte: new FormControl('', { nonNullable: true }),
    email: new FormControl('', { nonNullable: true }),
    tel: new FormControl('', { nonNullable: true }),
    comentario: new FormControl('', { nonNullable: true }),
  });

  onSubmit() {
    console.log(this.reactiveForm.value);
  }
}
