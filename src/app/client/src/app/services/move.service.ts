import { Injectable } from '@angular/core';
import {Http, Response} from "@angular/http";
import {Observable} from "rxjs/Observable";
import "rxjs/Rx";
//import {Config} from "../models/config";

@Injectable()
export class MoveService {

  private _postsURL = "move";

  constructor(private http: Http) { }

  getMove(data): Observable<any> {
    return this.http
        .post(this._postsURL, data)
        .map((response: Response) => {
            return response.json();
        })
        .catch(this.handleError);
  }

  private handleError(error: Response) {
      return Observable.throw(error.statusText);
  }

}
