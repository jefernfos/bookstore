# bookstore

## Features
| Feature                | Status      | Description                                                              |
|------------------------|-------------|--------------------------------------------------------------------------|
| User Authentication    | Implemented | Allow users to sign up, log in, and log out securely.                    |
| Admin Dashboard        | Implemented | Provide administrators with tools to manage ebooks and view sales data.  |
| File Uploading         | Implemented | Support uploading of ebooks and images (for admins only)                 |
| Input Validation       | Implemented | Validate all user inputs with regex and other tools.                     |
| Get Image From Server  | Implemented | Get uploaded images from the server.                                     |
| Get Ebook From Server  | In Progress | Get uploaded ebooks from the server.                                     |
| User Profile           | In Progress | Add user profiles with customizable information and avatars.             |
| Desktop Design         | In Progress | Interface for desktop devices.                                           |
| Genre Management       | Planned     | Categorize ebooks by genre.                                              |
| User Library           | Planned     | Allow users to view and manage their purchased ebooks.                   |
| User Reviews           | Planned     | Allow users to leave reviews and ratings for ebooks.                     |
| Remember Me            | Planned     | Keep users logged in even after closing the browser and manage sessions. |
| Catalog Filters        | Planned     | Filtering options for browsing the ebook catalog.                        |
| Payment Integration    | Planned     | Integrate payment gateways for purchasing ebooks.                        |
| Sales Analytics        | Planned     | Analytical tools for admins.                                             |
| Multi-language Support | Planned     | Support for multiple languages.                                          |
| Mobile Design          | Planned     | Interface for mobile devices.                                            |

## Usage

To install follow the same instructions as in [php-mine-framework](https://github.com/jefernfos/php-mini-framework)

To access the admin dashboard you must create an account, then change the type from `user` to `admin` in the database.
Example: (you must replace `YOUR USERNAME` with the username of the account you created.)
```sql
UPDATE users SET type = 'admin' WHERE username = 'YOUR USERNAME';
```