import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ClientareaComponent } from './clientarea.component';

describe('ClientareaComponent', () => {
  let component: ClientareaComponent;
  let fixture: ComponentFixture<ClientareaComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ClientareaComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(ClientareaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
