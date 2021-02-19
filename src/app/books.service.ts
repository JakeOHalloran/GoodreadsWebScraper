import { Injectable } from '@angular/core';
import { BOOKS } from './mockbooks';
import { Book } from './book';

@Injectable({
  providedIn: 'root'
})
export class BooksService {

  constructor() { }

  getBooks(authorPageURL: string): Book[] {
    return BOOKS;
  }
}
