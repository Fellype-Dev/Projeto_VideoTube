/// <reference types="cypress" />

describe('VideoTube CRUD Operations', () => {

    let createdVideoId;

    const testVideo = {
        titulo: 'Test Video Title',
        descricao: 'This is a test video description',
        url: 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        categoria: 'MUSICA'
    };

    const updatedVideo = {
        titulo: 'Updated Test Video Title',
        descricao: 'Updated test video description',
        url: 'https://www.youtube.com/watch?v=9bZkp7q19f0',
        categoria: 'JOGOS'
    };

    before(() => {
        cy.visit('/videos');
        cy.get('nav').should('be.visible');
    });

    it('should load the homepage with welcome message', () => {
        cy.visit('/');
        cy.get('h1').should('contain', 'Bem-vindo ao Catálogo de Vídeos');
        cy.contains('a', 'Ver Vídeos').should('exist');
    });

    it('should navigate to videos listing', () => {
        cy.visit('/');
        cy.contains('a', 'Ver Vídeos').click();
        cy.url().should('include', '/videos');
        cy.get('h1').should('contain', 'Nossos Vídeos');
        cy.get('.card').should('exist');
    });

    describe('Create Video', () => {
        it('should navigate to create video page', () => {
            cy.visit('/videos');
            cy.get('[data-cy="create-video-button"]').click();
            cy.url().should('include', '/videos/create');
            cy.get('h1').should('contain', 'Adicionar Novo Vídeo');
        });

        it('should validate the form', () => {
            // 1. Navegue até a página de criação
            cy.visit('/videos/create');

            // 2. Verifique se o formulário está completo
            cy.get('[data-cy="video-form"]').should('exist').and('be.visible');

            // 3. Verifique se os campos do partial estão carregados
            cy.get('#titulo').should('exist');
            cy.get('#url').should('exist');
            cy.get('#categoria').should('exist');

            // 4. Teste a validação
            cy.get('[data-cy="video-form"]').submit();

            // Verifique os erros de validação
            cy.get('#titulo').should('have.class', 'is-invalid');
            cy.get('#url').should('have.class', 'is-invalid');
            cy.get('#categoria').should('have.class', 'is-invalid');

            // Teste específico para URL do YouTube
            cy.get('#url').type('invalid-url');
            cy.get('#url').should('have.class', 'is-invalid');
            cy.contains('.invalid-feedback', 'Apenas URLs do YouTube são permitidas').should('be.visible');
        });

        it('should create a new video', () => {

            cy.visit('/videos/create');

            cy.get('[data-cy="video-title-input"]')
                .should('be.visible')
                .and('not.be.disabled')

            cy.fillVideoForm(testVideo);
            cy.get('[data-cy="video-form"]').submit();

            cy.visit('/videos');
        });
    });

    describe('Read Video', () => {
        it('should view video details', function () {

            cy.visit('/videos');
            // Verify details page
            cy.url().should('include', '/videos');
            cy.contains('.card-title', testVideo.titulo)  // Localiza pelo título
                .parents('.card')                          // Sobe para o elemento card
                .find('a[href*="/videos/"]')              // Encontra o link de detalhes
                .first()                                   // Pega o primeiro (se houver múltiplos)
                .click();                                  // Clica no link

            // 3. Agora verifique os elementos na página de DETALHES
            cy.url().should('match', /\/videos\/\d+/);  // Verifica se está na página de detalhes

            // Verificações na página de detalhes:
            cy.get('h1').should('contain', testVideo.titulo);  // Título principal
            cy.get('.badge').should('contain', 'Música');      // Categoria
            cy.get('.description-box').should('contain', testVideo.descricao); // Descrição
            cy.get('iframe').should('exist');                  // Player
        });
    });

    describe('Update Video', () => {
        it('should navigate to edit page', () => {
            // Go back to the list
            cy.visit('/videos');

            // Find our test video and click edit
            cy.contains('.card-title', testVideo.titulo)
                .parents('.card')
                .find('[data-cy="edit-button"]')
                .click();

            //pega o id do vídeo criado
            cy.location('pathname').should('match', /\/videos\/\d+/)
                .then((path) => {
                    createdVideoId = path.split('/')[2];
                    cy.log(`ID do vídeo criado: ${createdVideoId}`);
                });

            // Verify edit page
            cy.url().should('include', '/edit');
            cy.get('h1').should('contain', 'Editar Vídeo');
        });

        it('should update the video', () => {
            // Update form fields
            cy.visit(`/videos/${createdVideoId}/edit`);
            cy.url().should('include', '/edit');
            cy.get('h1').should('contain', 'Editar Vídeo');


            cy.get('#titulo').clear().type(updatedVideo.titulo);
            cy.get('#descricao').clear().type(updatedVideo.descricao);
            cy.get('#url').clear().type(updatedVideo.url);
            cy.get('#categoria').select(updatedVideo.categoria);

            // Submit the form
            cy.get('form').submit();

            // Verify success
            cy.url().should('include', '/videos');
            cy.get('.alert-success').should('contain', 'sucesso');
            cy.contains('.card-title', updatedVideo.titulo).should('exist');
        });
    });

    describe('Delete Video', () => {
        it('should delete the video', () => {

            cy.visit('/videos');
            // Find our updated video and click delete
            cy.contains('.card-title', updatedVideo.titulo)
                .parents('.card')
                .find('[data-cy="delete-button"]')
                .click();

            // Confirm the deletion
            cy.on('window:confirm', (text) => {
                expect(text).to.contains('Tem certeza que deseja excluir este vídeo?');
                return true;
            });

            // Verify success
            cy.get('.alert-success').should('contain', 'sucesso');
            cy.contains('.card-title', updatedVideo.titulo).should('not.exist');
        });
    });

    describe('Character Counters', () => {
        it('should display character counters', () => {
            cy.visit('/videos/create');

            // Test title counter
            cy.get('#titulo').type('Test');
            cy.get('#titulo-counter').should('contain', '4/150');

            // Test description counter
            cy.get('#descricao').type('Description test');
            cy.get('#descricao-counter').should('contain', '16/2048');

            // Test URL counter
            cy.get('#url').type('https://test.com');
            cy.get('#url-counter').should('contain', '16/2048');
        });
    });
});