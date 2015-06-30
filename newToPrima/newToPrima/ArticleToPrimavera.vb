Module ArticleToPrimavera

    Sub Main(ByVal codbarras As String, ByVal description As String, ByVal motor As ErpBS800.ErpBS)
        
        Try
            
            Dim createArticle As GcpBE800.GcpBEArtigo
            createArticle = New GcpBE800.GcpBEArtigo()

            createArticle.Artigo = codbarras
            createArticle.Descricao = description
            createArticle.TipoArtigo = "3"
            createArticle.IVA = "23"
            createArticle.DeduzIVA = True
            createArticle.PercIvaDedutivel = 100.0
            createArticle.PercIncidenciaIVA = 100.0
            createArticle.CodBarras = codbarras
            createArticle.SujeitoDevolucao = True
            createArticle.ArmazemSugestao = "A1"
            createArticle.UnidadeBase = "UN"
            createArticle.UnidadeCompra = "UN"
            createArticle.UnidadeEntrada = "UN"
            createArticle.UnidadeSaida = "UN"
            createArticle.UnidadeTaric = "UN"
            createArticle.UnidadeVenda = "UN"

            'aqui é para o artigo aparecer na lista de artigos a escolher
            Dim artm As GcpBE800.GcpBEArtigoMoeda
            artm = New GcpBE800.GcpBEArtigoMoeda()
            artm.Moeda = "EUR"
            artm.Artigo = codbarras
            artm.Unidade = "UN"
            artm.PVP1IvaIncluido = False


            Dim result As Boolean
            Dim erroVal As String = ""
            Dim erroCria As String = ""
            'se dá true quer dizer que posso criar o artigo
            result = motor.Comercial.Artigos.ValidaActualizacao(createArticle, erroVal)
            If result Then
                motor.Comercial.Artigos.Actualiza(createArticle, erroCria)
                motor.Comercial.Artigos.PreencheDadosRelacionados(createArticle)
                motor.Comercial.ArtigosPrecos.Actualiza(artm)
            End If


        Catch ex As Exception
            MsgBox(ex.Message)
        End Try

    End Sub

End Module
