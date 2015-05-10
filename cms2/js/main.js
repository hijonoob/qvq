if (typeof jQuery === 'undefined') { throw new Error('Beetle Escape\'s JavaScript requires jQuery') }

tinyMCE.init({
        mode : "textareas"
});

// confirmação de removação de usuário - visão de listagem de usuários
jQuery(function() {
  $('.removeusuario').click(
    function(e) {
      return confirm("Confirma remover usuário?");
    }
  )
});

// confirmação de removação de notícia - visão de listagem de notícias
jQuery(function() {
  $('.removenoticia').click(
    function(e) {
      return confirm("Confirma remover usuário?");
    }
  )
});

// Ativação de contraste
jQuery(function() {
  $('#acao-contraste a').click(
    function(e) {
      if($.cookie('contraste') === null) {
        $.cookie('contraste', 'on');
        $('body').addClass('contraste');
        e.preventDefault();
        return false;
      }else {
        if($.cookie('contraste') == 'on'){
          $.cookie('contraste', 'off');
          $('body').removeClass('contraste');
          e.preventDefault();
          return false;
        }else{
          $.cookie('contraste', 'on');
          $('body').addClass('contraste');
          e.preventDefault();
          return false;
        }
      }
  });

  if($.cookie('contraste') == 'on') {
    $('body').addClass('contraste');
    return false;
  }
});

// Validação de formulários
(function($,W,D)
{
    var validacao = {};

    validacao.util =
    {
        setupFormValidation: function()
        {
            // formulário de adicionar usuários
            $("#adicionausuario").validate({
                rules: {
                    usuario: "required",
                    nome: "required",
                    email: {
                        required: true,
                        email: true
                    },
                    senha: "required",
                    senhaconfirma: {
                      equalTo: "#senha"
                    },

                },
                messages: {
                    usuario: "Favor preencher o usuário",
                    nome: "Favor preencher o nome completo",
                    email: "Favor preencher com e-mail válido",
                    senha: {
                        required: "Favor preencher uma senha",
                        minlength: "A senha precisa ter pelo menos 5 caracteres"
                    },
                    senhaconfirma: {
                        required: "Favor preencher uma senha",
                        equalTo: "Favor preencher a mesma senha que no campo senha"
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
            // formulário de edição de usuários
            $("#editausuario").validate({
                rules: {
                    usuario: "required",
                    nome: "required",
                    email: {
                        required: true,
                        email: true
                    }

                },
                messages: {
                    usuario: "Favor preencher o usuário",
                    nome: "Favor preencher o nome completo",
                    email: "Favor preencher com e-mail válido"
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
            // formulário de registro
            $("#registro").validate({
                rules: {
                    usuario: "required",
                    nome: "required",
                    email: {
                        required: true,
                        email: true
                    },
                    senha: "required",
                    senhaconfirma: {
                      equalTo: "#senha"
                    },

                },
                messages: {
                    usuario: "Favor preencher o usuário",
                    nome: "Favor preencher o nome completo",
                    email: "Favor preencher com e-mail válido",
                    senha: {
                        required: "Favor preencher uma senha",
                        minlength: "A senha precisa ter pelo menos 5 caracteres"
                    },
                    senhaconfirma: {
                        required: "Favor preencher uma senha",
                        equalTo: "Favor preencher a mesma senha que no campo senha"
                    }
                },
            });
            // formulário de adição de notícia
            $("#adicionanoticia").validate({
                rules: {
                    id: "required",
                    titulo: "required",
                    descricao: "required",
                    autor: "required",
                    data: "required",
                    texto: "required"
                },
                messages: {
                    id: "Favor preencher o id da notícia",
                    titulo: "Favor preencher o título da notícia",
                    descricao: "Favor preencher a descrição da notícia",
                    autor: "Favor preencher o autor da notícia",
                    data: "Favor preencher a data da notícia",
                    texto: "Favor preencher o corpo de texto da notícia"
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
            // formulário de edição de notícia
            $("#editanoticia").validate({
                rules: {
                    id: "required",
                    titulo: "required",
                    descricao: "required",
                    autor: "required",
                    data: "required",
                    texto: "required"
                },
                messages: {
                    id: "Favor preencher o id da notícia",
                    titulo: "Favor preencher o título da notícia",
                    descricao: "Favor preencher a descrição da notícia",
                    autor: "Favor preencher o autor da notícia",
                    data: "Favor preencher a data da notícia",
                    texto: "Favor preencher o corpo de texto da notícia"
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    }

    //inicia validação após carregamento do dom
    $(D).ready(function($) {
        validacao.util.setupFormValidation();
    });
})(jQuery, window, document);