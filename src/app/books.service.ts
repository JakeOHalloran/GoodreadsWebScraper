import { Injectable } from '@angular/core';
import { Book } from './book';

import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class BooksService {
  books: Book[] = [];

  constructor(private http: HttpClient) { }

  // Get the authors book data from the goodreads web scraper
  getBooks(authorPageURL: string, limit: number): Observable<Book[]> {
      return this.http.post<Book[]>("http://localhost/Projects/Angular Study/GoodreadsScraperProject/goodreads-web-scraper/PHP/index.php", { 
        request: "getLatestBooks",
        authorPageURL: authorPageURL,
        limit: limit });
  }
}
