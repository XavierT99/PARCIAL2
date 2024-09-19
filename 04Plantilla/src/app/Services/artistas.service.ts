import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

import { IArtista } from '../interfaces/iartista';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ArtistasService {
  apiurl = 'http://localhost/sexto/Proyectos/03MVC/controllers/artistas.controller.php?op=';
  
  constructor(private http: HttpClient) {}

  // Buscar artista por nombre
  buscar(texto: string): Observable<IArtista[]> {
    const formData = new FormData();
    formData.append('texto', texto);
    return this.http.post<IArtista[]>(this.apiurl + 'buscar', formData);
  }

  // Obtener todos los artistas
  todos(): Observable<IArtista[]> {
    return this.http.get<IArtista[]>(this.apiurl + 'todos');
  }

  // Obtener un artista por ID
  uno(artista_id: number): Observable<IArtista> {
    const formData = new FormData();
    formData.append('artista_id', artista_id.toString());
    return this.http.post<IArtista>(this.apiurl + 'uno', formData);
  }

  // Eliminar un artista por ID
  eliminar(artista_id: number): Observable<number> {
    const formData = new FormData();
    formData.append('artista_id', artista_id.toString());
    return this.http.post<number>(this.apiurl + 'eliminar', formData);
  }

  // Insertar un nuevo artista
  insertar(artista: IArtista): Observable<string> {
    const formData = new FormData();
    formData.append('nombre', artista.nombre);
    formData.append('apellido', artista.apellido);
    formData.append('fecha_nacimiento', artista.fecha_nacimiento);
    formData.append('nacionalidad', artista.nacionalidad);
    return this.http.post<string>(this.apiurl + 'insertar', formData);
  }

  // Actualizar un artista existente
  actualizar(artista: IArtista): Observable<string> {
    const formData = new FormData();
    formData.append('artista_id', artista.artista_id.toString());
    formData.append('nombre', artista.nombre);
    formData.append('apellido', artista.apellido);
    formData.append('fecha_nacimiento', artista.fecha_nacimiento);
    formData.append('nacionalidad', artista.nacionalidad);
    return this.http.post<string>(this.apiurl + 'actualizar', formData);
  }
}
