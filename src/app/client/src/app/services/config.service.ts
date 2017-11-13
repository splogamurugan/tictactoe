import { Injectable } from '@angular/core';
import {Http, Response} from "@angular/http";
import {Observable} from "rxjs/Observable";
import "rxjs/Rx";
import {Config} from "../models/config";

@Injectable()
export class ConfigService {

  private _postsURL = "config";

  constructor(private http: Http) { }

  getConfig(): Observable<Config> {
    return this.http
        .get(this._postsURL)
        .map((response: Response) => {
            return <Config>response.json();
        })
        .catch(this.handleError);
  }

  private handleError(error: Response) {
      return Observable.throw(error.statusText);
  }

}
