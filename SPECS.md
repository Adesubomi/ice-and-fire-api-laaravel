## Ice and Fire API - assignment

### Requirements
1. [GET] /api/external-books?name=<nameOfBook> - Get list of books from external api
    #### Expected output
    ```
    {
        status_code: 200,
        status: 'success',
        data: [ <fetch list of books from external api> ]
    }
    ```

2. [POST] /api/v1/books - Store a book to the local database
    #### Request Body
    ```
    {
        name: <string>
        isbn: <string>
        author: <string>
        country: <string>
        number_of_pages: <string>
        publisher: <string>
        release_date: <string>
    }
    ```
   #### Expected output
    ```
    {
        status_code: 200,
        status: 'success',
        data: {
            book: { <book model resource> }
        }
    }
    ```

3. [GET] /api/v1/books - Get list of books from local database
    #### Expected output
    ```
    {
        status_code: 200,
        status: 'success',
        data: {
            books: [ <list of books from local api> ]
        }
    }
    ```

4. [PATCH] /api/v1/books/{id} - Update a book entry
    #### Request Body
    ```
    {
        name: <string>
        isbn: <string>
        author: <string>
        country: <string>
        number_of_pages: <string>
        publisher: <string>
        release_date: <string>
    }
    ```
    #### Expected output
    ```
    {
        status_code: 200,
        status: 'success',
        message: 'The book "My First Book" was updated successfully',
        data: { updated book model resource }
    }
    ```

5. [DELETE] /api/v1/books/{id} - Delete a book entry
   #### Expected output
    ```
    {
        status_code: 204,
        status: 'success',
        message: 'The book "My First Book" was deleted successfully',
        data: {}
    }
    ```    

5. [GET] /api/v1/books/{id} - Show a book entry
    #### Expected output
    ```
    {
        status_code: 200,
        status: 'success',
        data: { book model resource }
    }
    ```
