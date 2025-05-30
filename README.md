# 📺 VideoTube - Plataforma de Gerenciamento de Vídeos

**Uma plataforma minimalista para organizar e assistir seus vídeos do YouTube favoritos**
## 🖼️ Screenshots

| Página Principal | Página do Vídeo |
|------------------|-----------------|
| ![Tela inicial do VideoTube](https://imgur.com/VY4XYRD.png) | ![Visualização do vídeo](https://i.imgur.com/LOgozdY.png) |

## ✨ Funcionalidades

- ✅ **Adição simplificada** - Basta colar a URL do YouTube
- 🖼️ **Thumbnails automáticas** - Capturadas diretamente do YouTube
- 🗂️ **Organização por categorias** - Jogos, Música, Tecnologia e mais
- 📱 **Totalmente responsivo** - Funciona em qualquer dispositivo


## 🛠 Tecnologias Principais
- **Backend**: Laravel 9+
- **Frontend**: Bootstrap 5 + JavaScript Vanilla
- **Banco de Dados**: MySQL
- **ORM**: Eloquent

## 🗃 Estrutura do Banco de Dados

### 📊 Tabela `videos`
```sql
CREATE TABLE `videos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `descricao` text,
  `url` varchar(2048) NOT NULL,
  `categoria` enum('JOGOS','ENSINO','MUSICA','TECNOLOGIA','ESPORTES','OUTROS') NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

## 🚀 Como Usar

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/videotube.git
```
2. Instale as dependências:
```bash
composer install
npm install
```
3. Configure o ambiente:
```bash
cp .env.example .env
php artisan key:generate
```
4. Execute as migrations:
```bash
php artisan migrate
```
5. Inicie o servidor:
```bash
php artisan serve
```
