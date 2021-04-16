import { Injectable } from '@angular/core';
import { Book } from './book';

import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class BooksService {

  constructor(private http: HttpClient) { }

  // Get the authors books from the goodreads web scraper
  getBooks(authorPageURL: string, limit: number): Observable<Book[]> {
    return this.http.post<Book[]>("http://localhost/Projects/Angular Study/GoodreadsScraperProject/goodreads-web-scraper/PHP/index.php", { 
        request: "getBooks",
        authorPageURL: authorPageURL,
        limit: limit });
  }

  // Get a specific books data from the goodreads web scraper
  getBook(bookPageURL: string): Observable<Book> {
    return this.http.post<Book>("http://localhost/Projects/Angular Study/GoodreadsScraperProject/goodreads-web-scraper/PHP/index.php", { 
      request: "getBook",
      bookPageURL: bookPageURL });
  }
}
