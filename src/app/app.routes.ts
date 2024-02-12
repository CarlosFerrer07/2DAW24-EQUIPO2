import { Routes } from '@angular/router';
import { InicioComponent } from './views/inicio/inicio.component';
import { EstanciaComponent } from './views/estancia/estancia.component';
import { InscripcionComponent } from './views/inscripcion/inscripcion.component';
import { SobreNosotrosComponent } from './views/sobre-nosotros/sobre-nosotros.component';

export const routes: Routes = [
    { path: '', redirectTo: 'inicio', pathMatch: 'full' },
    { path: 'inicio', component: InicioComponent },
    { path: 'estancia', component: EstanciaComponent },
    { path: 'inscripcion', component: InscripcionComponent },
    { path: 'sobre-nosotros', component: SobreNosotrosComponent },
   
];
