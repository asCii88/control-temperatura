using System;
using System.Runtime.Serialization;

namespace interfazMasterBD
{
	/// <summary>
	/// Excepción generada cuando el CRC calculado es erróneo.
	/// </summary>
	public class CrcErrorException : Exception, ISerializable
	{
		public CrcErrorException()
		{
		}

	 	public CrcErrorException(string message) : base(message)
		{
		}

		public CrcErrorException(string message, Exception innerException) : base(message, innerException)
		{
		}

		// This constructor is needed for serialization.
		protected CrcErrorException(SerializationInfo info, StreamingContext context) : base(info, context)
		{
		}
	}
}