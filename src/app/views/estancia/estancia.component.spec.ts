import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EstanciaComponent } from './estancia.component';

describe('EstanciaComponent', () => {
  let component: EstanciaComponent;
  let fixture: ComponentFixture<EstanciaComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [EstanciaComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(EstanciaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
