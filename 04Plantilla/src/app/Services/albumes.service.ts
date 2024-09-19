import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

import { IAlbum } from '../interfaces/ialbum';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AlbumesService {
  apiurl = 'http://localhost/sexto/Proyectos/03MVC/controllers/albumes.controller.php?op=';
  
  constructor(private http: HttpClient) {}

  // Buscar álbum por título
  buscar(texto: string): Observable<IAlbum[]> {
    const formData = new FormData();
    formData.append('texto', texto);
    return this.http.post<IAlbum[]>(this.apiurl + 'buscar', formData);
  }

  // Obtener todos los álbumes
  todos(): Observable<IAlbum[]> {
    return this.http.get<IAlbum[]>(this.apiurl + 'todos');
  }

  // Obtener un álbum por ID
  uno(album_id: number): Observable<IAlbum> {
    const formData = new FormData();
    formData.append('album_id', album_id.toString());
    return this.http.post<IAlbum>(this.apiurl + 'uno', formData);
  }

  // Eliminar un álbum por ID
  eliminar(album_id: number): Observable<number> {
    const formData = new FormData();
    formData.append('album_id', album_id.toString());
    return this.http.post<number>(this.apiurl + 'eliminar', formData);
  }

  // Insertar un nuevo álbum
  insertar(album: IAlbum): Observable<string> {
    const formData = new FormData();
    formData.append('titulo', album.titulo);
    formData.append('genero', album.genero);
    formData.append('anio_lanzamiento', album.anio_lanzamiento.toString());
    formData.append('discografica', album.discografica);
    return this.http.post<string>(this.apiurl + 'insertar', formData);
  }

  // Actualizar un álbum existente
  actualizar(album: IAlbum): Observable<string> {
    const formData = new FormData();
    formData.append('album_id', album.album_id.toString());
    formData.append('titulo', album.titulo);
    formData.append('genero', album.genero);
    formData.append('anio_lanzamiento', album.anio_lanzamiento.toString());
    formData.append('discografica', album.discografica);
    return this.http.post<string>(this.apiurl + 'actualizar', formData);
  }
}
