Imports System
Imports System.IO
Imports System.Text

Public Class ChooseFile

    Public ficheiro As String
    Public qtdart As Integer

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Btnchoosefile.Click

        OFDChooseFile.InitialDirectory = "C:\"
        OFDChooseFile.Title = "Abrir um ficheiro  (txt)"
        OFDChooseFile.Filter = "Text Files(*.txt)|*.txt"
        OFDChooseFile.ShowDialog()
        TBxUrlFile.Text = OFDChooseFile.FileName
        ficheiro = OFDChooseFile.FileName
    End Sub

    Private Sub BtnImport_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles BtnImport.Click
        Dim textline, texterros As String
        texterros = ""
        'essa variavel vai me servir para quando eu fizer o split dos ;
        Dim strArray() As String
        Dim qtdart As Integer
        qtdart = 0
        
        Dim objReader As New System.IO.StreamReader(ficheiro)

        'VOU ABRIR O MOTOR PRIMAVERA
        Try
            Dim motor As ErpBS800.ErpBS
            motor = New ErpBS800.ErpBS()
            'abre a empresa
            motor.AbreEmpresaTrabalho(StdBE800.EnumTipoPlataforma.tpProfissional, "FAFEDIS", "User", "1")

            'aqui é meu ciclo para ler o meu ficheiro dos artigos
            Do While objReader.Peek() <> -1

                'li a linha do meu ficheiro
                textline = objReader.ReadLine()
                strArray = Split(textline, ";")
                If Len(strArray(0)).Equals(13) Then
                    'aqui é que vou criar no primavera
                    If Not (motor.Comercial.Artigos.Existe(strArray(0))) Then
                        ArticleToPrimavera.Main(strArray(0), strArray(1), motor)
                        qtdart = qtdart + 1
                    End If
                Else
                    'aqui devia guardar as linhas com erros
                    texterros = texterros & textline & vbNewLine
                End If
            Loop

            'aqui vou excrever num ficheiro as minhas linhas que não foram criados no primavera
            If texterros <> "" Then
                'aqui crio o ficheiro de erros
                Dim path As String = "C:\erros create article.txt"
                Dim fs As FileStream = File.Create(path)
                fs.Close()
                'aqui vou escrever nele
                Dim objWriter As New System.IO.StreamWriter(path)
                objWriter.Write(texterros)
                objWriter.Close()
            End If

            'fecho a empresa
            motor.FechaEmpresaTrabalho()

        Catch ex As Exception
            MsgBox(ex.Message)
        End Try

        MsgBox("Importação Concluído, foram criados " & qtdart & " artigos")

    End Sub

End Class