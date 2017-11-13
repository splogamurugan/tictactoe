import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import {ConfigService} from "./services/config.service";

import { AppComponent } from './app.component';
import { GameComponent } from './game/game.component';
import { MoveService } from "./services/move.service";
@NgModule({
  declarations: [
    AppComponent,
    GameComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule
  ],
  providers: [ConfigService, MoveService],
  bootstrap: [AppComponent]
})
export class AppModule { }
