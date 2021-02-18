// Mock data to be used by shelf component until backend developed

import { Book } from './book';

export const BOOKS: Book[] = [
  { id: 1, 
    title: 'Book 1',
    partialDescription: 'Every day we make choices—about what to buy or eat, about financial investments or our children’s health and education, even about the causes we champion or the planet itself. Unfortunately ...', 
    description: 'Every day we make choices—about what to buy or eat, about financial investments or our children’s health and education, even about the causes we champion or the planet itself. Unfortunately, we often choose poorly. Nudge is about how we make these choices and how we can make better ones. Using dozens of eye-opening examples and drawing on decades of behavioral science research, Nobel Prize winner Richard H. Thaler and Harvard Law School professor Cass R. Sunstein show that no choice is ever presented to us in a neutral way, and that we are all susceptible to biases that can lead us to make bad decisions. But by knowing how people think, we can use sensible “choice architecture” to nudge people toward the best decisions for ourselves, our families, and our society, without restricting our freedom of choice.', 
    coverURL: 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1348322381i/3450744._SY400_.jpg', 
    rating: 3 },
  { id: 2, title: 'Book 2', description: 'description 2', partialDescription: 'description 2', coverURL: 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1348322381i/3450744._SY400_.jpg', rating: 3 },
  { id: 3, title: 'Book 3', description: 'description 3', partialDescription: 'description 2', coverURL: 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1348322381i/3450744._SY400_.jpg', rating: 3 },
  { id: 4, title: 'Book 4', description: 'description 4', partialDescription: 'description 2', coverURL: 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1348322381i/3450744._SY400_.jpg', rating: 3 },
  { id: 5, title: 'Book 5', description: 'description 5', partialDescription: 'description 2', coverURL: 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1348322381i/3450744._SY400_.jpg', rating: 3 },
  { id: 6, title: 'Book 6', description: 'description 6', partialDescription: 'description 2', coverURL: 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1348322381i/3450744._SY400_.jpg', rating: 3 },
  { id: 7, title: 'Book 7', description: 'description 7', partialDescription: 'description 2', coverURL: 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1348322381i/3450744._SY400_.jpg', rating: 3 }
];