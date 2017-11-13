import { Component, OnInit } from '@angular/core';
import {ConfigService} from "../services/config.service";
import {MoveService} from "../services/move.service";
import {Config} from "../models/config";


@Component({
  selector: 'app-game',
  templateUrl: './game.component.html',
  styleUrls: ['./game.component.css']
})
export class GameComponent implements OnInit {

  _config: Config;
  _blocks: any[];
  _result;
  _boardFreeze:boolean;

  constructor(private configService: ConfigService, private moveService: MoveService) {
  }

  getConfig(): void {
      this.configService.getConfig()
          .subscribe(
              resultArray => this._config = resultArray,
              error => console.log("Error :: " + error)
          )
  }

  setSpace(row, col): void {
      this._blocks[row][col] = this._config.space;
  }

  setPlayer(row, col): void {
    if (this._blocks[row][col] == this._config.space 
      && !this._boardFreeze
    ) {
      this._blocks[row][col] = this._config.opponent;
      this.getMove(row, col);
    }
  }

  setOpponent(row, col): void {
    this._blocks[row][col] = this._config.player;
  }

  getMove(row, col): void {
    var that = this;
    this._boardFreeze = true;
    this.moveService.getMove(this._blocks)
    .subscribe(
        function(resultArray) {
          that._boardFreeze = false;
          if (resultArray[1] >=0 && resultArray[0] >=0) {
            that.setOpponent(resultArray[1], resultArray[0]);
            console.log(resultArray);
            if (resultArray[3] == that._config.player) {
              that._result = 'Bot is the winner!';
              that._boardFreeze = true;
            } else if (resultArray[3] == that._config.opponent) {
              that._result = 'You are the winner!';
              that._boardFreeze = true;
            }
          } else {
            //that.setSpace(row, col);
            that._result = 'Game draw!';
            that._boardFreeze = true;
          }
        },
        function(error) {
          that.setSpace(row, col);
          that._result = 'Had to reset your turn since there was an error in response!';
          //let resultArray = [1, 1, that._config.player, 0];
          //that.setOpponent(resultArray[0], resultArray[1]);
          console.log("Error :: " + error);

        }
    )
  }

  ngOnInit(): void {
      this._config = {"player":"o","opponent":"x","space":"","blocks":3,"playerScore":10,"opponentScore":-10};
      this.getConfig();
      this._blocks = new Array();
      this._boardFreeze=false;
      for (let i=0; i<this._config.blocks; i++) {
        this._blocks.push([]);
        for (let j=0; j<this._config.blocks; j++) {
          this._blocks[i].push(this._config.space);
        }
      }
      console.log(this._blocks);
      
  }

}
