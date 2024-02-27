import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatIconModule } from '@angular/material/icon'

const materialModule = [
  MatIconModule
]
@NgModule({
  declarations: [],
  imports: [
    CommonModule,
    ...materialModule
  ],
  exports: [
    ...materialModule
  ]
})
export class MaterialModule { }
