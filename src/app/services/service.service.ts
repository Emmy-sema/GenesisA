import { Injectable } from '@angular/core';
import { Subject } from 'rxjs'
@Injectable({
  providedIn: 'root'
})
export class ServiceService {

  private scroll = new Subject<Boolean>();
  currentScroll = this.scroll.asObservable()

 
  updateScroll(value:Boolean){
    this.scroll.next(value);
  }
  
  private flip = new Subject<Boolean>();
  currentFlip = this.flip.asObservable()

  updateFlip(value:Boolean){
    this.flip.next(value)
  }
}
