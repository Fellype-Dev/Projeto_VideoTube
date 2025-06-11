Cypress.Commands.add('fillVideoForm', (videoData) => {
  cy.get('[data-cy="video-title-input"]').type(videoData.titulo);
  cy.get('[data-cy="video-description-textarea"]').type(videoData.descricao);
  cy.get('[data-cy="video-url-input"]').clear().type(videoData.url);
  cy.get('[data-cy="video-category-select"]').select(videoData.categoria);
});