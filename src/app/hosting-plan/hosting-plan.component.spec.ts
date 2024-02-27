import { ComponentFixture, TestBed } from '@angular/core/testing';

import { HostingPlanComponent } from './hosting-plan.component';

describe('HostingPlanComponent', () => {
  let component: HostingPlanComponent;
  let fixture: ComponentFixture<HostingPlanComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [HostingPlanComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(HostingPlanComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
